<template>
  <div class="hero-body bg-body">
    <div class="container bg-container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style scoped>
/* .bg-body {

  background-color: #08aeea;
  background-image: linear-gradient(90deg, #08aeea 0%, #2af598 100%);
}
*/
.bg-body {
  background: linear-gradient(
    to bottom,
    #293545 0px,
    #293545 50px,
    #f2f6fa 50px,
    #f2f6fa 100%
  );
}
</style>
