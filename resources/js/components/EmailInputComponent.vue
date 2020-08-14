<template>
    <div>
        <v-text-field label="メールアドレス" placeholder="メールアドレスを入力してください" :rules="emailRules" v-model="email" name="email" type="email"></v-text-field>
        <div v-if="validationErrors.email" class="errors-wrap">
            <span v-for="error in validationErrors.email" :key="error.id" class="error-text">
                {{ error }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: [
      'oldValue',
      'errors'
    ],
    data () {
        return {
          email: this.oldValue,
          validationErrors: this.errors,
          emailRules: [
            value => !!value || 'メールアドレスは必須です',
          ],
        }
    },
}
</script>