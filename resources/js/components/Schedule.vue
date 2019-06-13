<template>
    <div>
        <header style="display: flex; align-items: center; margin-bottom: 20px;">
            <h1>Текущая неделя: {{getDate()}}</h1>
            <div style="margin-right: 0; margin-left: auto;">
                <el-select v-model="chosenDay" placeholder="День недели" @change="selectDay" clearable>
                    <el-option
                            v-for="item in daysOfTheWeek"
                            :key="item.en"
                            :label="item.ru"
                            :value="item.en">
                    </el-option>
                </el-select>
                <el-select v-model="form.user_id" placeholder="Преподователь" @change="getScheduleByUser" clearable>
                    <el-option
                            v-for="item in teachers"
                            :key="item.user_id"
                            :label="fullName(item)"
                            :value="item.user_id">
                    </el-option>
                </el-select>
            </div>
        </header>
        <el-row :gutter="20" v-show="chosenDay === 'monday' || !chosenDay || chosenDay === 'tuesday' || chosenDay === 'wednesday'">
            <el-col :span="8" v-show="chosenDay === 'monday' || !chosenDay">
                <h1 class="header">Понедельник</h1>
                <el-table
                        :data="monday"
                        border>
                    <el-table-column
                            prop="lesson"
                            label="Занятие">
                    </el-table-column>
                    <el-table-column
                            prop="group"
                            label="Группа">
                    </el-table-column>
                    <el-table-column
                            prop="time"
                            label="Время"
                            :width="110">
                    </el-table-column>
                </el-table>
            </el-col>
            <el-col :span="8" v-show="chosenDay === 'tuesday' || !chosenDay">
                <h1 class="header">Вторник</h1>
                <el-table
                        :data="tuesday"
                        border>
                    <el-table-column
                            prop="lesson"
                            label="Занятие">
                    </el-table-column>
                    <el-table-column
                            prop="group"
                            label="Группа">
                    </el-table-column>
                    <el-table-column
                            prop="time"
                            label="Время"
                            :width="110">
                    </el-table-column>
                </el-table>
            </el-col>
            <el-col :span="8" v-show="chosenDay === 'wednesday' || !chosenDay">
                <h1 class="header">Среда</h1>
                <el-table
                        :data="wednesday"
                        border>
                    <el-table-column
                            prop="lesson"
                            label="Занятие">
                    </el-table-column>
                    <el-table-column
                            prop="group"
                            label="Группа">
                    </el-table-column>
                    <el-table-column
                            prop="time"
                            label="Время"
                            :width="110">
                    </el-table-column>
                </el-table>
            </el-col>
        </el-row>
        <el-row :gutter="20" style="margin-top: 20px;" v-show="chosenDay === 'thursday' || !chosenDay || chosenDay === 'friday' || chosenDay === 'saturday'">
            <el-col :span="8" v-show="chosenDay === 'thursday' || !chosenDay">
                <h1 class="header">Четверг</h1>
                <el-table
                        :data="thursday"
                        border>
                    <el-table-column
                            prop="lesson"
                            label="Занятие">
                    </el-table-column>
                    <el-table-column
                            prop="group"
                            label="Группа">
                    </el-table-column>
                    <el-table-column
                            prop="time"
                            label="Время"
                            :width="110">
                    </el-table-column>
                </el-table>
            </el-col>
            <el-col :span="8" v-show="chosenDay === 'friday' || !chosenDay">
                <h1 class="header">Пятница</h1>
                <el-table
                        :data="friday"
                        border>
                    <el-table-column
                            prop="lesson"
                            label="Занятие">
                    </el-table-column>
                    <el-table-column
                            prop="group"
                            label="Группа">
                    </el-table-column>
                    <el-table-column
                            prop="time"
                            label="Время"
                            :width="110">
                    </el-table-column>
                </el-table>
            </el-col>
            <el-col :span="8" v-show="chosenDay === 'saturday' || !chosenDay">
                <h1 class="header">Суббота</h1>
                <el-table
                        :data="saturday"
                        border>
                    <el-table-column
                            prop="lesson"
                            label="Занятие">
                    </el-table-column>
                    <el-table-column
                            prop="group"
                            label="Группа">
                    </el-table-column>
                    <el-table-column
                            prop="time"
                            label="Время"
                            :width="110">
                    </el-table-column>
                </el-table>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="12">
                <div class="block" style="margin-top: 50px">
                    <div class="header">Добавить расписание</div>
                    <el-form class="form" ref="form" :model="form" @submit.native.prevent="" label-width="120px" style="width: 100%" border>
                        <el-form-item label="День недели" :error="errors.day">
                            <el-select v-model="form.day" @focus="clearInput" placeholder="День недели" id="day">
                                <el-option
                                        v-for="item in daysOfTheWeek"
                                        :key="item.en"
                                        :label="item.ru"
                                        :value="item.en">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item id="time" label="Время" :error="errors.time">
                            <el-time-select
                                    @focus="clearInput"
                                    class="timePicker"
                                    placeholder="Начало"
                                    v-model="form.dateFrom"
                                    :picker-options="{
                                      start: '09:00',
                                      step: '00:15',
                                      end: '22:00'
                                    }">
                            </el-time-select>
                            <el-time-select
                                    @focus="clearInput"
                                    class="timePicker"
                                    placeholder="Конец"
                                    v-model="form.dateTo"
                                    :picker-options="{
                                      start: '09:00',
                                      step: '00:15',
                                      end: '22:00',
                                      minTime: form.dateFrom
                                    }">
                            </el-time-select>
                        </el-form-item>
                        <el-form-item label="Дисциплина" :error="errors.lesson_id">
                            <el-select v-model="form.lesson_id" placeholder="Дисциплина" @focus="clearInput" id="lesson_id">
                                <el-option
                                        v-for="lesson in lessons"
                                        :key="lesson.lesson_id"
                                        :label="lesson.name"
                                        :value="lesson.lesson_id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Преподователь" :error="errors.user_id">
                            <el-select v-model="form.user_id" id="user_id" placeholder="Преподователь" @change="selectTeacher">
                                <el-option
                                        v-for="item in teachers"
                                        :key="item.user_id"
                                        :label="fullName(item)"
                                        :value="item.user_id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Группа" :error="errors.group_id">
                            <el-select id="group_id" v-model="form.group_id" placeholder="Группа" @focus="clearInput">
                                <el-option
                                        v-for="group in groupList"
                                        :key="group.group_id"
                                        :label="group.name"
                                        :value="group.group_id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item style="margin-bottom: 0">
                            <el-button type="primary" @click="storeSchedule">Добавить</el-button>
                            <el-button>Сбросить</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data() {
            return {
                select: '',
                form: {
                    user_id: '',
                    lesson_id: '',
                    day: '',
                    group_id: '',
                    dateFrom: '',
                    dateTo: '',
                },
                chosenTeacher: '',
                chosenDay: null,
                schedule: {},
                errors: {
                    user_id: '',
                    lesson_id: '',
                    day: '',
                    group_id: '',
                    time: '',
                },
                daysOfTheWeek: [
                    {
                        'en': 'monday',
                        'ru': 'Понедельник',
                    },
                    {
                        'en': 'tuesday',
                        'ru': 'Вторник',
                    },
                    {
                        'en': 'wednesday',
                        'ru': 'Среда'
                    },
                    {
                        'en': 'thursday',
                        'ru': 'Четверг'
                    },
                    {
                        'en': 'friday',
                        'ru': 'Пятница'
                    },
                    {
                        'en': 'saturday',
                        'ru': 'Суббота'
                    },
                ],
            }
        },

        mounted() {
            this.$store.dispatch('getScheduleIndex');
            this.$store.dispatch('getServiceInfo');
        },

        computed: {
            ...mapGetters([
                'teachers',
                'lessons',
                'groupList'
            ]),
            monday() {
                return this.$store.getters.scheduleByUser.monday
            },
            tuesday() {
                return this.$store.getters.scheduleByUser.tuesday
            },
            wednesday() {
                return this.$store.getters.scheduleByUser.wednesday
            },
            thursday() {
                return this.$store.getters.scheduleByUser.thursday
            },
            friday() {
                return this.$store.getters.scheduleByUser.friday
            },
            saturday() {
                return this.$store.getters.scheduleByUser.saturday
            },
        },
        methods: {
            fullName(item) {
                return item.first_name + ' ' + item.last_name;
            },

            selectTeacher(item) {
                this.chosenTeacher = item;
                this.getScheduleByUser();
            },

            getDate() {
                let today = new Date();
                let dd = String(today.getDate()).padStart(2, '0');
                let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                let yyyy = today.getFullYear();

                today = dd + '.' + mm + '.' + yyyy + ' ' + this.dayOfTheWeek();
                return today;
            },

            dayOfTheWeek () {
                let today = new Date();

                let weekday = new Array(7);
                weekday[0] = "Воскресенье";
                weekday[1] = "Понедельник";
                weekday[2] = "Вторник";
                weekday[3] = "Среда";
                weekday[4] = "Четверг";
                weekday[5] = "Пятница";
                weekday[6] = "Суббота";

                return weekday[today.getDay()]
            },

            showNotification(message) {
                this.$notify({
                    title: 'Успешно',
                    message: message,
                    type: 'success',
                    duration: 1500
                });
            },

            storeSchedule() {
                this.$store.dispatch('saveSchedule', this.form)
                    .then(() => {
                        this.$store.dispatch('getScheduleByUser', {id: this.form.user_id });
                        this.chosenTeacher = this.form.user_id;
                        this.$refs['form'].resetFields();
                        this.showNotification('Добавлено');
                    })
                    .catch(errors => {
                        _.forOwn(errors.response.data.errors, (val, key) => {
                            if (key === 'dateFrom' || key === 'dateTo') {
                                this.errors['time'] = val[0];
                            } else {
                                this.errors[key] = val[0];
                            }
                        });
                    });
            },

            getScheduleByUser() {
                this.$store.dispatch('getScheduleByUser', {id: this.form.user_id })
            },

            clearInput(event) {
                if (event.$el && event.$el.classList.contains('timePicker')) {
                    this.errors['time'] = null;
                    return true;
                }

                this.errors[event.target.id] = null;
            },

            selectDay() {
                this.form.day = this.chosenDay
            },
        }
    }
</script>

<style>
    h1 {
        margin-bottom: 10px;
        font-size: 40px;
    }
    .form{
        padding: 20px;
        border: 1px solid #EBEEF5;
    }
    .header {
        font-size: 14px;
        color: #363636;
        font-weight: bold;
        padding: 13px 10px;
        border: 1px solid #EBEEF5;
        border-bottom: none;
    }
    .el-range-separator {
        width: 6% !important;
    }
</style>