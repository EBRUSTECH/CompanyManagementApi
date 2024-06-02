<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/dashboard">Dashboard</router-link>
      <router-link to="/profile">Profile</router-link>
      <router-link to="/login">Login</router-link>
      <router-link to="/register">Register</router-link>
      <button @click="logout" v-if="isAuthenticated">Logout</button>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem('token');
    },
  },
  methods: {
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    },
  },
};
</script>

<style>
/* Add your styles here */
</style>
