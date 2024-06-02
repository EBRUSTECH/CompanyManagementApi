<template>
  <div>
    <h2>{{ isEditing ? 'Edit Company' : 'Add Company' }}</h2>
    <form @submit.prevent="saveCompany">
      <input v-model="company_name" placeholder="Company Name" required />
      <input v-model="company_email" type="email" placeholder="Company Email" required />
      <input v-model="country_id" placeholder="Country ID" required />
      <button type="submit">{{ isEditing ? 'Update' : 'Add' }}</button>
    </form>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  props: {
    company: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      company_name: this.company.company_name || '',
      company_email: this.company.company_email || '',
      country_id: this.company.country_id || '',
    };
  },
  computed: {
    isEditing() {
      return !!this.company.id;
    },
  },
  methods: {
    async saveCompany() {
      try {
        if (this.isEditing) {
          await apiClient.put(`/companies/${this.company.id}`, {
            company_name: this.company_name,
            company_email: this.company_email,
            country_id: this.country_id,
          });
        } else {
          await apiClient.post('/companies', {
            company_name: this.company_name,
            company_email: this.company_email,
            country_id: this.country_id,
          });
        }
        this.$emit('saved');
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
