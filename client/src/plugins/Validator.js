import { i18n } from 'boot/i18n'

export default class Validator {
  constructor (formModel) {
    this.errors = {
      error_message: null
    }

    if (formModel) {
      for (const name in formModel) {
        if (formModel.hasOwnProperty(name)) {
          this.errors[name] = null
        }
      }
    }
  }

  setError (field, errors) {
    this.errors[field] = errors[field] ? errors[field][0] : null
  }

  setErrors (res) {
    const validation = res.response.data.errors
    if (!validation) {
      if (res.response.data.error === 'invalid_grant') {
        this.errors.error_message = i18n.messages[i18n.locale].wrong_credentials
      }

      return
    }

    for (const field in validation) {
      if (validation.hasOwnProperty(field)) {
        if (field === 'error_message') {
          this.errors.error_message = validation[field]
          continue
        }
        this.errors[field] = validation[field][0]
      }
    }
  }

  resetFieldError (fieldName) {
    if (this.errors.hasOwnProperty(fieldName)) {
      this.errors[fieldName] = null
    }
    this.errors.error_message = null
  }

  resetErrors () {
    for (const error in this.errors) {
      if (this.errors.hasOwnProperty(error)) {
        this.errors[error] = null
      }
    }
  }
}
