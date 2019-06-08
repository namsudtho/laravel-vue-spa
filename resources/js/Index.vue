<template>
  <section
    id="main"
    class="hero is-fullheight is-default is-bold"
  >
    <div class="hero-head">
      <Navbar/>
    </div>
    <router-view></router-view>
    <div class="hero-foot">
      <div class="container">
        <div class="tabs is-centered">
          <ul>
            <li>
              <a>ICT Security Team</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import Navbar from './components/Navbar.vue';

export default {
  components: {
    Navbar
  },
  data() {
    return {
      //
    };
  }
};
</script>
