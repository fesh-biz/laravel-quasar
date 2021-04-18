export default class Validator {
  constructor (formModel) {
    this.errors = {
      errorMessage: null
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

    for (const field in validation) {
      if (validation.hasOwnProperty(field)) {
        if (field === 'message' || (field === 'errors' && typeof validation.errors === 'string')) {
          this.errors.errorMessage = validation[field]
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
  }

  resetErrors () {
    for (const error in this.errors) {
      if (this.errors.hasOwnProperty(error)) {
        this.errors[error] = null
      }
    }
  }
}
