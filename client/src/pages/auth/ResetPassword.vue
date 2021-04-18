<template>
  <div class="row justify-center">
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-4 col-xl-4">
      <q-form
        @submit="onSubmit"
        class="q-gutter-md"
      >
        <!-- Title -->
        <q-card>
          <q-card-section>
            <div class="text-h6">{{ $t('reset_password') }}</div>
          </q-card-section>

          <q-separator/>

          <!-- password -->
          <q-card-section>
            <q-input
              outlined
              dense
              autocomplete
              type="password"
              v-model="form.password"
              :label="$t('password')"
              :error="!!validator.errors.password"
              :error-message="validator.errors.password"
              @input="validator.resetErrors()"
            />

            <q-input
              outlined=""
              dense=""
              type="password"
              v-model="form.password_confirmation"
              :label="$t('password_confirmation')"
              autocomplete

              :error="!!validator.errors.password"
              :error-message="validator.errors.password"

              @input="validator.resetFieldError('password')"
            />

            <q-banner v-if="infoMessage" rounded inline-actions class="text-white bg-positive">
              {{ infoMessage }}
            </q-banner>

            <q-banner v-if="validator.errors.errorMessage" rounded inline-actions class="text-white bg-red">
              {{ validator.errors.errorMessage }}
            </q-banner>
          </q-card-section>

          <q-separator/>

          <!-- Buttons -->
          <q-card-actions class="q-pa-md">
            <q-btn :loading="formIsBusy" :label="$t('reset_password')" type="submit" color="primary"/>
          </q-card-actions>
        </q-card>
      </q-form>
    </div>
  </div>
</template>

<script>
import Validator from '../../plugins/Validator'

const formModel = {
  password: '',
  password_confirmation: ''
}

export default {
  name: 'ResetPassword',
  data () {
    return {
      form: formModel,
      formIsBusy: false,
      validator: new Validator(formModel),
      infoMessage: null
    }
  },

  computed: {
    token () {
      return this.$router.currentRoute.params.token
    },

    email () {
      return this.$router.currentRoute.query.email
    }
  },

  methods: {
    onSubmit () {
      this.formIsBusy = true
      this.$post(`password-reset/${this.token}`, {
        password: this.form.password,
        password_confirmation: this.form.password_confirmation
      }).then((res) => {
        this.formIsBusy = false

        this.infoMessage = res.data.data.message
        this.$router.push({ name: 'login' })
      })
        .catch((err) => {
          this.formIsBusy = false
          this.validator.setErrors(err)
        })
    }
  }
}
</script>
