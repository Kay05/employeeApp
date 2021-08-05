<template>
    <employee-form :employee="employee" />
</template>

<script>
  import EmployeeForm from '../components/EmployeeForm'

  export default {
    name: 'CreateEmployee',
    components: {
      EmployeeForm,
    },


    data: () => ({
        employee: {
            first_name: '',
            last_name: '',
            contact_number: '',
            email: '',
            address: '',
            dob: null,
            city: '',
            postal_code: '',
            country: '',
            skills: [
                {
                    name: '',
                    pivot: {
                        experience: '',
                        rating: ''
                    }
                }
            ],
        },
    }),

    computed: {

    },

    methods: {
    
    },
    mounted() {
        document.title = 'Create Employee | EmployeeApp';
    }
  }
</script>