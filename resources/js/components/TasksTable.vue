<template>
  <div>
    <!-- edit -->
    <button @click="edit()" v-if="!editMode" class="btn btn-primary">
        Edit
    </button>
    <button @click="update()" v-else class="btn btn-warning">
        Save
    </button>

    <!-- Table -->
    <b-table striped hover :items="tasks" :fields="fields" :tbody-tr-class="rowClass">
        <template slot="name" slot-scope="{ item }">
            <a @click="deleteTask(item.id)" v-if="!editMode" class="nameTag">
                {{item.name}}
            </a>
            <input type="text" v-else v-model="item.name">
        </template>
        <template slot="completed_at" slot-scope="{ item }">
            <span>
                {{completedAt(item.completed_at)}}
            </span>
        </template>
        <template slot="priorities" slot-scope="{ item }">
            <span v-for="(priority, index) in item.priorities" :key="index" :class="priorityClass(priority)">
                {{ priority.name }}
            </span>
        </template>
    </b-table>
  </div>
</template>

<script>
  export default {
    mounted(){
        axios.get('/task').then(response => this.tasks = response.data)
    },
    data() {
      return {
        fields: [
            {
                key: 'name',
                sortable: true
            },
            {
                key:'completed_at',
                label:'Completed',
                sortable:true
            },
            {
                key:'priorities',
                label:'Priorities',
                sortable:true
            },
            {
                key: 'updated_at',
                label: 'Last Updated',
                sortable: true,
            }
        ],
        tasks:[],
        editMode:false,
      }
    },
    methods: {
        priorities: function (item) {
            return _.join(_.map(item.priorities, 'name'), ', ')
        },
        priorityClass: function (priority) {
            if (priority.name === 'urgent') {
                return 'badge badge-pill badge-danger'
            } else if (priority.name === 'important'){
                return 'badge badge-pill badge-warning'
            } else if (priority.name === 'ignored'){
                return 'badge badge-pill badge-secondary'
            } else if (priority.name === 'optional'){
                return 'badge badge-pill badge-info'
            }
        },
        completedAt(item){
            if (item == null){
                return "No"
            } else {
                return "Yes"
            }
        },
        rowClass(item){
            if (item.completed_at != null){
                return 'table-success'
            }
        },

        edit(){
            this.editMode=true;
        },

        update(){
            this.editMode=false;
            axios.put('/task', {_method: 'PUT', tasks: this.tasks});
        },

        deleteTask(id){
            axios.delete('/task/' + id).then(console.log('deleted'));
        },

    }
  }
</script>