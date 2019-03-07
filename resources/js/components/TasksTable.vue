<template>
    <div v-on:addnewtask="console.log('yeah')">
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
                <span v-if="!editMode">
                    {{ item.name }}
                </span>
                <div v-else>
                    <input type="text" v-model.lazy="item.name" :key="item.id">
                    <div>{{item.name}}</div>
                    <button type="button" class="btn btn-danger" @click="deleteTask(item.id)">Delete</button>
                </div>
            </template>
            <template slot="completed_at" slot-scope="{ item }">
                <span>
                    {{ completedAt(item.completed_at) }}
                </span>
            </template>
            <template slot="priorities" slot-scope="{ item }">
                <span v-for="(priority, index) in item.priorities" :key="index" :class="priorityClass(priority)">
                    {{ priority.name }}
                </span>
                <span @click="infoModal(item.id)" class="badge badge-pill badge-success">
                    <img src="https://img.icons8.com/ios-glyphs/26/000000/pencil.png" style="width: 50%; height: 50%">
                </span>
            </template>
        </b-table>


        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5>{{this.modalTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="checkbox" id="checkbox" v-model="completeChecked">
                    <label for="checkbox">
                        {{ completedChecker() }}
                    </label>  

                    <br>

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
    import {eventBus} from "../app";
    export default {
        created() {
            eventBus.$on('addtask', () => {
                this.get();
            });
        },
        mounted(){
            this.get()
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
            modalid:0,
            modalTitle:"Unknown Name",
            modalPriorities:"yeet",
            modalDate:"NOW",
            completeChecked:false,
            taskPriorities:[],
            index:0,

        }
        },
        methods: {
            get(){
                axios.get('/task').then(response => this.tasks = response.data);
            },
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

                console.log(this.updateTasks);
            },

            update(){
                this.editMode=false;
                axios.put('/task', { _method: 'PUT', tasks: this.tasks });
            },

            deleteTask(id){
                axios.delete('/task/' + id).then( 
                    this.index = this.tasks.map(function(x) {return x.id; }).indexOf(this.id),
                    this.tasks.splice(this.index,1)
                );
                this.editMode=false;
            },
            infoModal(id){
                this.modalid=id;
                let currentTask=this.tasks.find(x => x.id === id );
                this.modalTitle = currentTask.name;
                this.modalPriorities = currentTask.priorities.map( priority => priority.name);
                this.modalDate = currentTask.completed_at;

                this.taskPriorities=[];


                if(this.modalPriorities.includes('urgent')){
                    this.taskPriorities.push("1"); 
                }
                if(this.modalPriorities.includes('important')){
                    this.taskPriorities.push("2"); 
                }
                if(this.modalPriorities.includes('ignored')){
                    this.taskPriorities.push("3"); 
                }
                if(this.modalPriorities.includes('optional')){
                    this.taskPriorities.push("4"); 
                }


                if(this.modalDate != null){
                    this.completeChecked = true;
                } else {
                    this.completeChecked = false;
                }

                $('#infoModal').modal('toggle');
            },

            completedChecker(){
                if(this.completeChecked===true){
                    return "Completed";
                } else {
                    return "Not Completed Yet";
                }
            },

            updateInfo(){
                axios.put('/taskpriorities', {
                    _method : 'PUT', 
                    id: this.modalid, 
                    complete: this.completeChecked,
                    priorities: this.taskPriorities,
                }).then( axios.get('/task').then( this.get() ));
                $('#infoModal').modal('toggle')
            }
        },
    }
</script>