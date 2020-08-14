<template>
   <div>
        <v-text-field label="パスワード" :placeholder="placeholderText" :rules="passwordRules" v-model="password" name="password" type="password"></v-text-field>
        <div v-if="validationErrors.password" class="errors-wrap">
            <span v-for="error in validationErrors.password" :key="error.id" class="error-text">
                {{ error }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: [
      'errors',
      'placeholder',
    ],
    data () {
        return {
          password: '',
          placeholderText: this.placeholder,
          validationErrors: this.errors,
          passwordRules: [
            value => !!value || 'パスワードは必須です',
            value => (value && value.length <= 20 || 'パスワードは20文字以下です'),
            value => (value && value.length >= 6 || 'パスワードは6文字以上です')
          ]
        }
    },
}
</script>