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
            <!-- password -->
            <q-input
              dusk="rp-password-input"
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

            <!-- password_confirmation -->
            <q-input
              dusk="rp-password-confirmation-input"
              outlined=""
              dense=""
              type="password"
              v-model="form.password_confirmation"
              :label="$t('password_confirmation')"
              autocomplete

              :error="!!validator.errors.password_confirmation"
              :error-message="validator.errors.password_confirmation"

              @input="validator.resetFieldError('password_confirmation')"
            />

            <q-banner v-if="infoMessage" rounded inline-actions class="text-white bg-positive">
              {{ infoMessage }}
            </q-banner>

            <q-banner v-if="validator.errors.error_message" rounded inline-actions class="text-white bg-red">
              {{ validator.errors.error_message }}
            </q-banner>
          </q-card-section>

          <q-separator/>

          <!-- Buttons -->
          <q-card-actions class="q-pa-md">
            <q-btn dusk="rp-submit-button" :disable="formIsBusy" :loading="formIsBusy" :label="$t('reset_password')" type="submit" color="primary"/>
          </q-card-actions>
        </q-card>
      </q-form>
    </div>
  </div>
</template>

<script>
import Validator from '../../plugins/Validator'
import auth from 'src/plugins/auth'

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
    }
  },

  methods: {
    onSubmit () {
      this.formIsBusy = true
      this.$post('password-reset', {
        token: this.token,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation
      }).then((res) => {
        this.infoMessage = this.$t('your_password_has_been_successfully_reset') + '. ' + this.$t('you_ll_be_redirected_in_3_seconds')

        setTimeout(() => {
          auth.loginAndRedirect(res.data.access_token, res.data.user)
        }, 3000)
      })
        .catch((err) => {
          this.formIsBusy = false
          this.validator.setErrors(err)
        })
    }
  }
}
</script>
