import axios from 'axios';

export default {
    state: {
        teachers: {},
        schedule: {},
        pref: '/api',
        GET: {
            teachers: '/teachers',
            teacher: '/teachers/{id}',
            schedule: '/schedule-by-day'
        },
        POST: {
            teachers: '/teachers',
        },
        DELETE: {
            teacher: '/teachers/{id}'
        },
        PATCH: {

        },
        PUT: {
            teachers: '/teachers/{id}',
        },
    },
    getters: {
        teachersList(state) {
            return state.teachers;
        },
    },
    mutations: {
        addTeachers(store, teachers) {
            store.teachers = teachers;
        },
        addSchedule(store, schedule) {
            store.schedule = schedule;
        }
    },
    actions: {
        getTeachers(context){
            axios.get(context.state.pref + context.state.GET.teachers)
                .then(response => {
                    context.commit('addTeachers', response.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },

        getScheduleForTeacher(context, data) {
            axios.get(context.state.pref + context.state.GET.schedule, {'params' : data})
                .then(response => {
                    context.commit('addSchedule', response.data.data);
                })
                .catch((error) => {
                });
        }
    }
}