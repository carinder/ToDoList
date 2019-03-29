<template>
  <div>
    <!-- Table -->
    <b-table
      bordered
      hover
      :items="tasks"
      :fields="fields"
      :tbody-tr-class="rowClass"
      class="b-table"
    >
      <template slot="name" slot-scope="{ item }">
        <span>{{ item.name }}</span>
      </template>
      <template slot="completed_at" slot-scope="{ item }">
        <button @click="completedSwitch(item.id)" v-if="completedBool(item.completed_at)" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
        <button @click="completedSwitch(item.id)" v-else class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
      </template>
      <template slot="priorities" slot-scope="{ item }">
        <span
          v-for="(priority, index) in item.priorities"
          :key="index"
          :class="priorityClass(priority)"
        >{{ priority.name }}</span>
        <span @click="infoModal(item.id)" class="badge badge-pill badge-success">
          <img
            src="https://img.icons8.com/ios-glyphs/26/000000/pencil.png"
            style="width: 50%; height: 50%"
          >
        </span>
      </template>
      <template slot="updated_at" slot-scope="{ item }">
        <span>{{ item.updated_at }}</span>
      </template>
    </b-table>

    <div
      class="modal fade"
      id="infoModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="infoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <input type="text" v-model="modalTitle" class="form-control">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="checkbox" v-model="taskPriorities" value="1">
            <label>Urgent</label>
            <br>
            <input type="checkbox" v-model="taskPriorities" value="2">
            <label>Important</label>
            <br>
            <input type="checkbox" v-model="taskPriorities" value="3">
            <label>Ignored</label>
            <br>
            <input type="checkbox" v-model="taskPriorities" value="4">
            <label>Optional</label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click="updateInfo">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { eventBus } from "../app";
export default {
  created() {
    eventBus.$on("addtask", () => {
      this.get();
    });
  },
  mounted() {
    this.get();
  },
  data() {
    return {
      fields: [
        {
          key: "name",
          sortable: true
        },
        {
          key: "completed_at",
          label: "Completed",
          sortable: true
        },
        {
          key: "priorities",
          label: "Priorities",
          sortable: true
        },
        {
          key: "updated_at",
          label: "Last Updated",
          sortable: true
        }
      ],
      tasks: [],
      modalid: 0,
      modalTitle: "Unknown Name",
      modalPriorities: "unknown",
      modalDate: "now?",
      completeChecked: false,
      taskPriorities: []
    };
  },
  methods: {
    get() {
      axios.get("/task").then(response => (this.tasks = response.data));
    },
    priorities: function(item) {
      return _.join(_.map(item.priorities, "name"), ", ");
    },
    priorityClass: function(priority) {
      if (priority.name === "urgent") {
        return "badge badge-pill badge-danger";
      } else if (priority.name === "important") {
        return "badge badge-pill badge-warning";
      } else if (priority.name === "ignored") {
        return "badge badge-pill badge-secondary";
      } else if (priority.name === "optional") {
        return "badge badge-pill badge-info";
      }
    },
    completedBool(item) {
      if (item == null) {
        return false;
      } else {
        return true;
      }
    },
    rowClass(item) {
      if (item.completed_at != null) {
        return "table-success";
      }
    },
    deleteTask(id) {
      axios.delete("/task/" + id).then(
        (this.index = this.tasks
          .map(function(x) {
            return x.id;
          })
          .indexOf(this.id)),
        this.tasks.splice(this.index, 1)
      );
    },
    infoModal(id) {
      this.modalid = id;
      let currentTask = this.tasks.find(x => x.id === id);
      this.modalTitle = currentTask.name;
      this.modalPriorities = currentTask.priorities.map(
        priority => priority.name
      );
      this.modalDate = currentTask.completed_at;
      this.taskPriorities = [];

      if (this.modalPriorities.includes("urgent")) {
        this.taskPriorities.push("1");
      }
      if (this.modalPriorities.includes("important")) {
        this.taskPriorities.push("2");
      }
      if (this.modalPriorities.includes("ignored")) {
        this.taskPriorities.push("3");
      }
      if (this.modalPriorities.includes("optional")) {
        this.taskPriorities.push("4");
      }

      $("#infoModal").modal("toggle");
    },
    updateInfo() {
      axios
        .put("/taskpriorities", {
          _method: "PUT",
          id: this.modalid,
          priorities: this.taskPriorities,
          name: this.modalTitle,
        })
        .then(axios.get("/task").then(this.get()));
      $("#infoModal").modal("toggle");
    },
    completedSwitch(id){
      let completed = false;
      let currentTask = this.tasks.find(x => x.id === id);
      if(currentTask.completed_at === null){
        completed = false;
      } else {
        completed = true;
      }
      axios.put("/task",{
        _method : "PUT",
        id: id,
        completed: completed
      }).then(this.get());
    }
  }
};
</script>