<template>
  <q-btn-dropdown no-caps flat dense rounded icon="account_circle">
    <div class="row no-wrap q-pa-md">
      <div class="column items-center">
        <user-avatar :src="me.avatar"/>

        <div class="text-subtitle1 q-mt-md q-mb-xs">{{ me.name }}</div>

        <q-btn
          color="primary"
          :label="$t('logout')"
          @click="logout"
          push
          size="sm"
          v-close-popup
        />
      </div>
    </div>
  </q-btn-dropdown>
</template>

<script>
import Me from 'src/models/user/Me'
import UserAvatar from 'components/common/UserAvatar'

export default {
  name: 'UserMenu',

  components: {
    UserAvatar
  },

  data () {
    return {}
  },

  computed: {
    me () {
      return Me.query().first()
    }
  },

  methods: {
    logout () {
      this.$post('/logout')
        .then(() => {
          this.$q.cookies.remove('bearer')
          this.$q.cookies.remove('me')
          Me.deleteAll()
          this.$router.push({ name: 'login' })
        })
    }
  }
}
</script>
