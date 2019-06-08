<template>
  <nav
    class="navbar is-dark"
    role="navigation"
    aria-label="dropdown navigation"
    style="height: 70px;"
  >
    <div class="container">
      <div class="navbar-brand">
        <div class="navbar-item">
          <img
            height="28"
            :src="appLogo"
          >
          <b style="font-size: 20px;">&nbsp;&nbsp;{{ appName }}</b>
        </div>
        <a
          role="button"
          class="navbar-burger burger"
          :class="{ 'is-active' : showNav }"
          aria-label="menu"
          aria-expanded="false"
          data-target="navbarBasicExample"
          @click="showNav = !showNav"
        >
          <span aria-hidden="true"/>
          <span aria-hidden="true"/>
          <span aria-hidden="true"/>
        </a>
      </div>

      <div
        id="navbarBasicExample"
        class="navbar-menu"
        :class="{ 'is-active' : showNav }"
      >
        <div class="navbar-start">
          <router-link
            class="navbar-item"
            :to="{ name: 'home' }"
          >Home</router-link>
          <!--LOGGED USER-->
          <router-link
            v-for="route in routes.user"
            v-show="$auth.check(2)"
            :key="route.path"
            class="navbar-item"
            :to="{ name : route.path }"
          >{{ route.name }}</router-link>
          <!--LOGGED ADMIN-->
          <router-link
            v-for="route in routes.admin"
            v-show="$auth.check(1)"
            :key="route.path"
            class="navbar-item"
            :to="{ name : route.path }"
          >{{ route.name }}</router-link>
        </div>
        <div class="navbar-end">
          <!--UNLOGGED-->
          <router-link
            v-for="route in routes.unlogged"
            v-show="!$auth.check()"
            :key="route.path"
            class="navbar-item"
            :to="{ name : route.path }"
          >{{ route.name }}</router-link>
          <!--LOGOUT-->
          <div
            v-if="$auth.check()"
            class="navbar-item has-dropdown is-hoverable"
          >
            <a class="navbar-link">
              <img
                class="avatar"
                :src="avatar"
              >
            </a>

            <div class="navbar-dropdown is-right">
              <div
                v-if="$auth.user().role == 1"
                class="navbar-item is-size-6"
              >
                <label>{{ $auth.user().name }} (Admin)</label>
              </div>
              <div
                v-else
                class="navbar-item is-size-6"
              >
                <label>{{ $auth.user().name }}</label>
              </div>
              <a
                class="navbar-item is-size-6"
                href="#"
                @click.prevent="$auth.logout()"
              >Log out</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      appName: 'Laravel Vue Buefy',
      appLogo: `${window.location.origin}/storage/assets/img/logo.png`,
      showNav: false,
      routes: {
        // UNLOGGED
        unlogged: [{ name: 'Login', path: 'login' }],

        // LOGGED USER
        user: [{ name: 'Dashboard', path: 'dashboard' }],

        // LOGGED ADMIN
        admin: [{ name: 'Dashboard', path: 'admin.dashboard' }]
      }
    };
  },
  methods: {
    _link(name) {
      this.$router.push({ name: name });
    }
  },
  computed: {
    avatar: function() {
      const img = this.$auth.user().empid;
      return `https://empmobile.boonrawd.co.th/HCMPRD/${img}.JPG`;
    }
  }
};
</script>
<style scoped>
.hero .navbar {
  background-color: #293545;
}
.navbar-link {
  padding-top: 0;
  padding-bottom: 0;
}
.navbar-item img {
  max-height: 45px;
}
.avatar {
  max-width: 45px;
  margin-right: 4px;
  border: 2px solid #fff;
  border-radius: 50%;
}
</style>

