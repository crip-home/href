<template>
  <div class="href-list row">
    <div class="panel panel-primary">
      <div class="panel-heading">People shared hrefs</div>

      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Url</th>
            <th>Category</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

      <div class="panel-body bookmark-panel">

      </div>
    </div><!-- .panel -->
  </div>
</template>

<script>
  import api from '../../api/hrefs'

  export default {
    name: 'href-list',

    mounted () {
      this.$emit('href-list:mounted')
      let records = api.get(this.$route.params.page || 0)
      console.log(records)
    }
  }
</script>
