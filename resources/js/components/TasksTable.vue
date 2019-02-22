<template>
  <div>
    <b-table striped hover :items="tasks" :fields="fields" />
  </div>
</template>

<script>
  export default {
    mounted(){
        axios.get('/task').then(response => this.tasks = response.data)
    },
    data() {
      return {
        // Note 'isActive' is left out and will not appear in the rendered table
        tasks:[],
        fields: [
          {
              key:'completed_at',
              sortable:true
          },
          {
            key: 'name',
            sortable: true
          },
          {
            key: 'priorities',
            sortable: false
          },
          {
            key: 'updated_at',
            label: 'Last Updated',
            sortable: true,
            // Variant applies to the whole column, including the header and footer
            //variant: 'danger'
          }
        ],
      }
    }
  }
</script>