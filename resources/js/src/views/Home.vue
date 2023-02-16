<template>
  <div>
    ZapecHome

    {{ activeUserInfo }}
</div>
</template>

<script>
export default {
  name: 'ZapecHome',

  data() {
    return {

    };
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser
    },
  },

  mounted() {

  },
  created() {
    // console.log(localStorage.getItem('userInfo'));

  },
  methods: {

  },
};
</script>
