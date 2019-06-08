<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <div class="box">
            <h5 class="title has-text-grey">Login</h5>
            <b-message
              type="is-danger"
              v-if="has_error"
            >Error, {{ message_error }}</b-message>
            <form
              class="has-text-left"
              autocomplete="off"
              @submit.prevent="validate"
              method="post"
            >
              <b-field
                :type="errors.has('username')? 'is-danger': ''"
                :message="errors.first('username')"
              >
                <b-input
                  type="text"
                  icon="user-circle"
                  v-model="username"
                  name="username"
                  placeholder="Your Username"
                  v-validate="'required'"
                  autofocus
                ></b-input>
              </b-field>

              <b-field
                :type="errors.has('password')? 'is-danger': ''"
                :message="errors.first('password')"
              >
                <b-input
                  type="password"
                  icon="fingerprint"
                  v-model="password"
                  name="password"
                  placeholder="Your password"
                  v-validate="'required|min:3'"
                  password-reveal
                ></b-input>
              </b-field>
              <div class="field">
                <b-checkbox>Remember me</b-checkbox>
              </div>
              <button
                type="submit"
                class="button is-rounded is-block is-info is-fullwidth"
              >Login</button>
            </form>
          </div>
          <p class="has-text-grey">
            <a
              href="https://selfservice.boonrawd.co.th/accounts/Reset"
              target="_blank"
            >Forgot Password</a>
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      username: null,
      password: null,
      has_error: false,
      message_error: ''
    };
  },

  mounted() {
    //
  },

  methods: {
    validate() {
      this.$validator.validateAll().then(result => {
        if (result) {
          return this.login();
        }
        this.$toast.open({
          message: 'Form is not valid! Please check the fields.',
          type: 'is-danger',
          position: 'is-bottom'
        });
      });
    },
    login() {
      // get the redirect object
      var redirect = this.$auth.redirect();
      var app = this;
      this.$auth.login({
        params: {
          username: app.username,
          password: app.password
        },
        success: function() {
          // handle redirection
          const redirectTo = redirect
            ? redirect.from.name
            : this.$auth.user().role === 1
            ? 'home'
            : 'home';

          this.$router.push({ name: redirectTo });
        },
        error: function(error) {
          app.has_error = true;
          app.message_error = error.response.data.errors;
        },
        rememberMe: true,
        fetchUser: true
      });
    }
  }
};
</script>
