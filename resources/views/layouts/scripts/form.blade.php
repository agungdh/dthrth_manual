<script>
    function formValue(form) {
        let newForm = {}

        for (const key in form) {
            const element = form[key];

            newForm[key] = element.value
        }

        return newForm
    }

    function resetFormErrors(form) {
        for (const key in form) {
            const element = form[key];

            element.errors = []
        }
    }

    function hasAnyError(form) {
        for (const key in form) {
            const element = form[key];

            return element.errors.length > 0
        }

        return false
    }

    function getFormError(form, key) {
        return form[key]?.errors?.[0] || ''
    }

    function setFormData(form, data) {
        for (const key in form) {
            form[key].value = data[key]
        }
    }
</script>
