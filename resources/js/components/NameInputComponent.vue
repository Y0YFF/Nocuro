<template>
    <div>
        <v-text-field label="名前" placeholder="2文字以上30文字以下の文字列" :rules="nameRules" v-model="name" name="name"></v-text-field>
        <div v-if="validationErrors.name" class="errors-wrap">
            <span v-for="error in validationErrors.name" :key="error.id" class="error-text">
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
          name: this.oldValue,
          validationErrors: this.errors,
          nameRules: [
            value => !!value || '名前は必須です',
            value => (value && value.length <= 30 || '名前は30文字以下です'),
            value => (value && value.length >= 2 || '名前は2字以上です')
          ],
        }
    },
}
</script>