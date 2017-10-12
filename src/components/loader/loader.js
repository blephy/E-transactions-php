export default {
  name: 'Loader',
  computed: {
    isLoading() {
      return this.$store.state.showLoader;
    },
  },
}
