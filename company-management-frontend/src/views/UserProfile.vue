<template>
  <div>
    <h1>Profile</h1>
    <form @submit.prevent="updateProfile">
      <div>
        <label for="full_name">Full Name</label>
        <input id="full_name" v-model="profile.full_name" type="text" required />
      </div>
      <div>
        <label for="email">Email</label>
        <input id="email" v-model="profile.email" type="email" required />
      </div>
      <div>
        <label for="mobile">Mobile</label>
        <input id="mobile" v-model="profile.mobile" type="text" required />
      </div>
      <div>
        <label for="address">Address</label>
        <input id="address" v-model="profile.address" type="text" required />
      </div>
      <div>
        <label for="country_id">Country ID</label>
        <input id="country_id" v-model="profile.country_id" type="text" required />
      </div>
      <button type="submit">Update Profile</button>
    </form>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  name: 'UserProfile',
  data() {
    return {
      profile: {
        full_name: '',
        email: '',
        mobile: '',
        address: '',
        country_id: '',
      },
    };
  },
  async created() {
    try {
      const response = await apiClient.get('/user');
      this.profile = response.data;
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    async updateProfile() {
      try {
        await apiClient.put('/user', this.profile);
        alert('Profile updated successfully');
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
