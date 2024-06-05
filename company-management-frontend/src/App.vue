<template>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <router-link class="navbar-brand" to="/"
          >Company Management</router-link
        >
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-end"
          id="navbarNav"
        >
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link class="nav-link" to="/">Home</router-link>
            </li>
            <li class="nav-item" v-if="isAuthenticated">
              <router-link class="nav-link" to="/dashboard"
                >Dashboard</router-link
              >
            </li>
            <li class="nav-item" v-if="isAuthenticated">
              <router-link class="nav-link" to="/profile">Profile</router-link>
            </li>
            <li class="nav-item" v-if="!isAuthenticated">
              <router-link class="nav-link" to="#"
                >About Us</router-link
              >
            </li>
            <li class="nav-item" v-if="!isAuthenticated">
              <router-link class="nav-link" to="#"
                >Services</router-link
              >
            </li>
            <li class="nav-item" v-if="!isAuthenticated">
              <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item" v-if="!isAuthenticated">
              <router-link class="nav-link" to="/register"
                >Register</router-link
              >
            </li>
            <li class="nav-item" v-if="isAuthenticated">
              <button class="btn btn-link nav-link" @click="logout">
                Logout
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  data() {
    return {
      isAuthenticated: localStorage.getItem("token") !== null,
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.isAuthenticated = false;
      this.$router.push("/login");
    },
  },
};
</script>

<style>
.navbar-nav .nav-link {
  margin-right: 15px;
}

.navbar-brand {
  font-weight: bold;
}

.navbar {
  margin-bottom: 20px;
}
</style>
