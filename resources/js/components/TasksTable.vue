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
                <a v-if="!editMode" @click="infoModal(item.id)">
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
        <!--<div v-if="infoMode">
            {{this.modalTitle}}
        </div> --> 
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">{{this.modalTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-for="name in modalPriorities">
                        <li>{{name}}</li>
                    </div>
                    <p>Completed:</p>
                    <input type="checkbox" id="checkbox" v-model="modalChecked">
                    <label for="checkbox">
                        {{modalChecker()}}
                    </label>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateInfo">Save changes</button>
                </div>
                </div>
            </div>
        </div>
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

        modalTitle:"Unknown Name",
        modalPriorities:"yeet",
        modalDate:"NOW",
        modalChecked:true,
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

        infoModal(id){
            let currentTask=this.modalTitle=this.tasks.find(x => x.id === id);
            this.modalTitle = currentTask.name;
            this.modalPriorities = currentTask.priorities.map(priority => priority.name);
            this.modalDate = currentTask.completed_at;


            $('#infoModal').modal('toggle');
        },

        modalChecker(){
            if(this.modalChecked===true){
                return "Completed";
            } else {
                return "Not Completed Yet";
            }
        },

        updateInfo(){
            axios.put('/task', {_method : 'PUT', complete: this.modalChecked});
        }

    }
  }
</script>