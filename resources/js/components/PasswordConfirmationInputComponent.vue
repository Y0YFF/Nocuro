<template>
   <div>
        <v-text-field label="パスワードの確認" placeholder="6文字以上20文字以下の半角英数字" :rules="passwordRules" v-model="passwordConfirmation" name="password_confirmation" type="password"></v-text-field>
    </div>
</template>

<script>
export default {
    data () {
        return {
          passwordConfirmation: '',
          passwordRules: [
            value => !!value || 'パスワードは必須です',
            value => (value && value.length <= 20 || 'パスワードは20文字以下です'),
            value => (value && value.length >= 6 || 'パスワードは6文字以上です')
          ]
        }
    },
}
</script>