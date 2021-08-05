<template>
  <div>
    <employee-form :edit="true" :employee="employee" :actionLink="link" />
    <LoadingOverlay :loading="$store.state.isLoading"></LoadingOverlay>
  </div>
</template>

<script>
import EmployeeForm from "../components/EmployeeForm";
import LoadingOverlay from "../components/LoadingOverlay";

import axios from "axios";

export default {
  name: "EditEmployee",
  components: {
    EmployeeForm,
    LoadingOverlay,
  },

  data() {
    return {
      link: "",
      employee: {
        first_name: "Test",
        last_name: "Surname",
        contact_number: "0112345678",
        email: "test@email.com",
        address: "123 Tafara drive",
        dob: "1995-10-15",
        city: "Harare",
        postal_code: "1234",
        country: "Zimbabwe",
        skills: [
          {
            name: "Shopping",
            pivot: {
              experience: "2",
              rating: "3",
            },
          },
          {
            name: "Talking",
            pivot: {
              experience: "12",
              rating: "Beginner",
            },
          },
          {
            name: "Excel",
            pivot: {
              experience: "4",
              rating: "Beginner",
            },
          },
        ],
      },
    };
  },

  watch: {
    $route(to, from) {
      if (to.name === "EditEmployee") {
        this.getEmployee();
      }
    },
  },

  computed: {},

  methods: {
    getEmployee() {
      const employeeID = this.$route.params.employee_id;
      this.$store.commit("setIsLoading", true);

      axios
        .get(`/api/v1/employees/${employeeID}`)
        .then((response) => {
          this.employee = response.data.data;
          document.title = `${this.employee.first_name}  ${this.employee.last_name} | EmployeeApp`;
          this.link = `/api/v1/employees/${this.employee.id}`;
          this.$store.commit("setIsLoading", false);
        })
        .catch((error) => {
          console.log(error);
          this.$store.commit("setIsLoading", false);
        });
    },
  },
  mounted() {
    document.title = "Edit Employee | EmployeeApp";
    this.getEmployee();
  },
};
</script>
