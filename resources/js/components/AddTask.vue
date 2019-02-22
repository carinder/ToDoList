<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            +
        </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a New Task:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="taskName" placeholder="New Task Name">
                    <p>Urgent:</p>
                        <input type="checkbox" class="urgCheck"> 
                    <p>Important:</p>
                        <input type="checkbox" class="impCheck">
                    <p>Ignored:</p>
                        <input type="checkbox" class="ignCheck"> 
                    <p>Optional:</p>
                        <input type="checkbox" class="optCheck"> 
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
        mounted(){
            console.log("Add button mounted");
        },
        methods:{
            save(){
                axios.post('/task',{
                    name:document.querySelector('[name="taskName"]').value,

                    urgent:$('.urgCheck').is(":checked"),
                    important:$('.impCheck').is(":checked"),
                    ignored:$('.ignCheck').is(":checked"),
                    optional:$('.optCheck').is(":checked"),
                }).then(console.log('saved'));
            }
        },
    }
</script>