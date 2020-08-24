<template>
    <div>
        <v-text-field label="アカウントID" :placeholder="placeholderText" :rules="accountIdRules" v-model="accountId" name="account_id"></v-text-field>
        <div v-if="validationErrors.account_id" class="errors-wrap">
            <span v-for="error in validationErrors.account_id" :key="error.id" class="error-text">
                {{ error }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: [
      'oldValue',
      'errors',
      'placeholder',
    ],
    data () {
        return {
          accountId: this.oldValue,
          placeholderText: this.placeholder,
          validationErrors: this.errors,
          accountIdRules: [
            value => !!value || 'アカウントIDは必須です',
            value => (value && value.length <= 15 || 'アカウントIDは15文字以下です'),
            value => (value && value.length >= 4 || 'アカウントIDは4文字以上です')
          ],
        }
    },
}
</script>