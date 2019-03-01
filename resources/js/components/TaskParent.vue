<template>
    <div>
        <tasks-table @newtask="get()"></tasks-table>
        <add-task></add-task>
    </div>
</template>

<script>
    import taskstable from './TasksTable.vue';
    import addtask from './AddTask.vue';
 
    export default {
        components: {taskstable, addtask},
        methods:{
            get(){
                console.log('test');
            }
        }
    }
</script>