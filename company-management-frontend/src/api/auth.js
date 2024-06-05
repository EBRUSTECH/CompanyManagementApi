const auth = {

  isAuthenticated() {
    // Implement your authentication logic here
    // For example, check if a token is present in localStorage
    return localStorage.getItem("token") !== null;
    },
    
};

export default auth;
