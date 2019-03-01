<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
            +
        </button>

        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add a New Task:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" v-model="task.name">
                    <br>
                    <input type="checkbox" id="urgCheck" value="1" v-model="task.priorities"> 
                    <label for="urgCheck">Urgent</label>
                    <br>
                    <input type="checkbox" id="impCheck" value="2" v-model="task.priorities">
                    <label for="impCheck">Important</label>
                    <br>
                    <input type="checkbox" id="ignCheck" value="3" v-model="task.priorities"> 
                    <label for="ignCheck">Ignored</label>
                    <br>
                    <input type="checkbox" id="optCheck" value="4" v-model="task.priorities"> 
                    <label for="optCheck">Optional</label>

                    <span>{{task.priorities}}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button @click="save()" type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                task:{
                    name:'New Task',
                    priorities:[]
                },
                priorities:[]
            }
        },
        methods:{
            save(){
                axios.post('/task',{
                    name:this.task.name,
                    priorities:this.task.priorities,
                });
                $('#addModal').modal('toggle');
            }
        },
    }
</script>