<template>
  <div>
    <h2>My Companies</h2>
    <button @click="showAddForm = true">Add Company</button>
    <CompanyForm v-if="showAddForm" @saved="fetchCompanies" />
    <ul>
      <li v-for="company in companies" :key="company.id">
        {{ company.company_name }}
        <button @click="editCompany(company)">Edit</button>
        <button @click="deleteCompany(company.id)">Delete</button>
      </li>
    </ul>
    <CompanyForm v-if="currentCompany" :company="currentCompany" @saved="fetchCompanies" />
  </div>
</template>

<script>
import apiClient from '../api';
import CompanyForm from './CompanyForm.vue';

export default {
  components: {
    CompanyForm,
  },
  data() {
    return {
      companies: [],
      showAddForm: false,
      currentCompany: null,
    };
  },
  methods: {
    async fetchCompanies() {
      try {
        const response = await apiClient.get('/companies');
        this.companies = response.data;
        this.showAddForm = false;
        this.currentCompany = null;
      } catch (error) {
        console.error(error);
      }
    },
    editCompany(company) {
      this.currentCompany = company;
      this.showAddForm = false;
    },
    async deleteCompany(companyId) {
      try {
        await apiClient.delete(`/companies/${companyId}`);
        this.fetchCompanies();
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.fetchCompanies();
  },
};
</script>
