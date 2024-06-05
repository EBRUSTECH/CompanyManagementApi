<template>
  <div class="container mt-5">
    <div class="row">
      <!-- Add/Edit Company Section -->
      <div class="col-md-6 mb-4">
        <h4>{{ editingCompany ? "Edit Company" : "Add Company" }}</h4>
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submitCompany" class="form-group">
              <div class="form-group mb-3">
                <label for="companyName">Company Name</label>
                <input
                  v-model="companyName"
                  type="text"
                  class="form-control"
                  id="companyName"
                  placeholder="Company Name"
                  required
                />
              </div>
              <div class="form-group mb-3">
                <label for="companyEmail">Company Email</label>
                <input
                  v-model="companyEmail"
                  type="email"
                  class="form-control"
                  id="companyEmail"
                  placeholder="Company Email"
                  required
                />
              </div>
              <div class="form-group mb-4">
                <label for="country">Country</label>
                <select
                  v-model="selectedCountry"
                  class="form-control"
                  id="country"
                  required
                >
                  <option disabled value="">Choose...</option>
                  <option
                    v-for="country in countries"
                    :key="country.id"
                    :value="country.id"
                  >
                    {{ country.name }}
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">
                {{ editingCompany ? "Update Company" : "Add Company" }}
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Search Companies Section -->
      <div class="col-md-6 mb-4">
        <h4>Search Companies</h4>
        <input
          v-model="searchQuery"
          type="text"
          class="form-control mb-3"
          placeholder="Search Companies"
        />
        <ul class="list-group">
          <li
            class="list-group-item d-flex justify-content-between align-items-center"
            v-for="company in filteredCompanies"
            :key="company.id"
          >
            {{ company.company_name }}
            <div>
              <button
                @click="editCompany(company)"
                class="btn btn-sm btn-primary mr-2"
              >
                Edit
              </button>
              <button
                @click="deleteCompany(company.id)"
                class="btn btn-sm btn-danger"
              >
                Delete
              </button>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="row mt-5">
      <!-- Add/Edit Service Section -->
      <div class="col-md-12">
        <h4>{{ editingService ? "Edit Service" : "Add Service" }}</h4>
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="submitService" class="form-group">
              <div class="form-group mb-3">
                <label for="serviceName">Service Name</label>
                <input
                  v-model="serviceName"
                  type="text"
                  class="form-control"
                  id="serviceName"
                  placeholder="Service Name"
                  required
                />
              </div>
              <div class="form-group mb-4">
                <label for="serviceCompany">Select Company</label>
                <select
                  v-model="selectedCompany"
                  class="form-control"
                  id="serviceCompany"
                  required
                >
                  <option disabled value="">Choose...</option>
                  <option
                    v-for="company in userCompanies"
                    :key="company.id"
                    :value="company.id"
                  >
                    {{ company.company_name }}
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">
                {{ editingService ? "Update Service" : "Add Service" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "../api";

export default {
  data() {
    return {
      companyName: "",
      companyEmail: "",
      selectedCountry: "",
      searchQuery: "",
      editingCompany: null,
      companies: [],
      services: [],
      serviceName: "",
      selectedCompany: "",
      editingService: null,
      currentUser: "",
      countries: [],
      error: null,
    };
  },
  computed: {
    filteredCompanies() {
      return this.userCompanies.filter((company) =>
        company.company_name
          .toLowerCase()
          .includes(this.searchQuery.toLowerCase())
      );
    },
    userCompanies() {
      if (this.currentUser) {
        return this.companies.filter(
          (company) => company.user_id === this.currentUser.id
        );
      }
      return [];
    },
  },
  created() {
    this.fetchCurrentUser();
    this.fetchUserCompanies();
    this.fetchServices();
    this.fetchCountries();
  },
  methods: {
    async fetchCurrentUser() {
      try {
        const response = await apiClient.get("/user");
        this.currentUser = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async fetchUserCompanies() {
      try {
        const response = await apiClient.get("/companies");
        this.companies = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async fetchServices() {
      try {
        const response = await apiClient.get("/services");
        this.services = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async fetchCountries() {
      try {
        const response = await apiClient.get("/countries");
        this.countries = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async submitCompany() {
      try {
        if (this.editingCompany) {
          await apiClient.put(`/companies/${this.editingCompany.id}`, {
            company_name: this.companyName,
            company_email: this.companyEmail,
            country_id: this.selectedCountry,
          });
          // Update local companies array
          const index = this.companies.findIndex(
            (company) => company.id === this.editingCompany.id
          );
          if (index !== -1) {
            this.companies[index].company_name = this.companyName;
            this.companies[index].company_email = this.companyEmail;
            this.companies[index].country_id = this.selectedCountry;
          }
          this.editingCompany = null;
        } else {
          await apiClient.post("/companies", {
            company_name: this.companyName,
            company_email: this.companyEmail,
            country_id: this.selectedCountry,
          });
          // Clear form fields
          this.companyName = "";
          this.companyEmail = "";
          this.selectedCountry = "";
          // Fetch updated companies list
          this.fetchUserCompanies();
        }
      } catch (error) {
        console.error(error);
        if (error.response && error.response.data) {
          this.error = error.response.data.message;
        } else {
          this.error = "An error occurred while submitting the company.";
        }
      }
    },
    async submitService() {
      try {
        if (this.editingService) {
          await apiClient.put(`/services/${this.editingService.id}`, {
            name: this.serviceName,
          });
          // Update local services array
          const index = this.services.findIndex(
            (service) => service.id === this.editingService.id
          );
          if (index !== -1) {
            this.services[index].name = this.serviceName;
          }
          this.editingService = null;
        } else {
          await apiClient.post("/services", {
            company_id: this.selectedCompany,
            name: this.serviceName,
          });
          // Clear form fields
          this.serviceName = "";
          this.selectedCompany = "";
          // Fetch updated services list
          this.fetchServices();
        }
      } catch (error) {
        console.error(error);
        if (error.response && error.response.data) {
          this.error = error.response.data.message;
        } else {
          this.error = "An error occurred while submitting the service.";
        }
      }
    },
    async deleteCompany(companyId) {
      try {
        await apiClient.delete(`/companies/${companyId}`);
        // Remove deleted company from local array
        this.companies = this.companies.filter(
          (company) => company.id !== companyId
        );
      } catch (error) {
        console.error(error);
      }
    },
    editCompany(company) {
      this.editingCompany = company;
      this.companyName = company.company_name;
      this.companyEmail = company.company_email;
      this.selectedCountry = company.country_id;
    },
  },
};
</script>

<style>
body {
  background-color: #f8f9fa;
}

h4 {
  margin-bottom: 20px;
}

.form-group label {
  font-weight: bold;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #004085;
}

.alert {
  margin-top: 20px;
}

.list-group-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
