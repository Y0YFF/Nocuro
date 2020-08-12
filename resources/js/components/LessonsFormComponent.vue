<template>
    <div id="lessons-wrap">
        <div id="title-text" style="font-weight:600;">講義</div>
        <div class="lesson" v-for="lesson in lessons" :key="lesson.id">
            <div id="lesson-title-wrap">
                <v-text-field label="lesson_title" type="text" name="lesson_title[]"></v-text-field>
            </div>
            <div id="lesson-link-wrap">
                <v-text-field label="lesson_link" type="text" name="lesson_link[]"></v-text-field>
            </div>
        </div>
        <div id="add-lesson-button" style="text-align:center;">
            <v-btn fab dark small color="pink" @click="addLesson">
                <v-icon dark>fas fa-plus</v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
          lessons: [
            {
              title: '',
              link: '',
            }
          ],
        }
    },
    methods: {
        addLesson: function () {
          let lesson = {
            title: '',
            link: ''
          }
          this.lessons.push(lesson)
        }
      }
}
</script>