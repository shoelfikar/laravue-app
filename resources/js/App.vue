<template>
  <div>
    <div id="wrapper">
      <Sidebar />
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <Navbar />
        <router-view></router-view>
      </div>
      <Footer />
    </div>
  </div>
  </div>
</template>

<script>
  import Navbar from './components/Navbar';
  import Sidebar from './components/Sidebar';
  import Footer from './components/Footer';
  export default {
    components: {
      Navbar,
      Sidebar,
      Footer
    } 
  }
</script>