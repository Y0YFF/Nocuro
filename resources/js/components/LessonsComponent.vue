<template>
    <div>
        <div id="course-progress-wrap">
            <v-progress-linear :value="progress" height="40" striped rounded>
                <strong id="progress-text">{{ progress }}%</strong>
            </v-progress-linear>
        </div>
        <v-card v-for="lesson in lessons" :key="lesson.id" class="course-item" outlined>
            <div class="lesson-title-wrap">
                <a :href="lesson.link" class="lesson-title-text" target="_blank" rel="noopener noreferrer">{{ lesson.title }}</a>
            </div>
            <div class="check-button-wrap">
                <button type="button" class="check-button" @click="check(lesson)">
                    <span v-if="lesson.checked">
                        <i class="far fa-check-circle"></i>
                        完了
                    </span>
                    <span v-else>未完了</span>
                </button>
            </div>
        </v-card>
        <v-dialog
        v-model="dialog"
        max-width="400">
            <v-card>
                <v-card-title class="headline" style="font-weight:700;">
                    <i class="fas fa-star" style="color:#FFC107;"></i>
                    コースを修了しました！
                </v-card-title>
                <v-card-text>
                    お疲れ様です！<br>
                    今の気持ちやNocuroの感想をぜひTwitterでつぶやいてください！<br>
                </v-card-text>

            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props:{
        lessons: Array,
        authId: Number,
        courseId: String,
        checkedCount: Number,
    },
    data: function () {
        return {
            progress: 0,
            count: this.checkedCount,
            dialog: false,
        }
    },
    methods: {
        check: function(lesson) {

            let beforeProgress = Math.floor((this.count / this.lessons.length) * 100);

            if (lesson.checked) {

                lesson.checked = false
                this.count--;

            } else {

                lesson.checked = true;
                this.count++;

            }

            let afterProgress = Math.floor((this.count / this.lessons.length) * 100);

            this.progress = afterProgress;

            if (afterProgress === 100) {
                this.dialog = true;
            }

            let data = {
                'authId': this.authId,
                'courseId': this.courseId,
                'checkedCount': this.count,
                'beforeProgress': beforeProgress,
                'afterProgress': afterProgress,
            };

            axios.post('/lessons/' + lesson.id + '/check', data)
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });

        },
        calcProgress: function () {
            
            let percent = (this.count / this.lessons.length) * 100;

            this.progress = Math.floor(percent);
        },
    },
    created: function() {
        this.calcProgress();
    }
}
</script>