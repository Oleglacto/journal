import axios from 'axios';

export default {
    state: {
        lessons: [],
        pref: '/api',
        GET: {
            lessons: '/lessons',
            lesson: '/lessons/{id}'
        },
        POST: {
            lessons: '/lessons',
        },
        DELETE: {
            lesson: '/lessons/{id}'
        },
        PATCH: {

        },
        PUT: {
            lessons: '/lessons/{id}',
        },
    },
    getters: {
        lessonsList(state) {
            return state.lessons;
        },
    },
    mutations: {
        addLessons(store, lessons) {
            store.lessons = lessons;
        }
    },
    actions: {
        getLessons(context){
            axios.get(context.state.pref + context.state.GET.lessons, {})
                .then(response => {
                    context.commit('addLessons', response.data.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },

        saveLesson(context, data) {
            axios.post(context.state.pref + context.state.POST.lessons, data)
                .then(response => {
                    context.commit('addLessons', response.data.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },

        updateLesson(context, data) {
            axios.put(context.state.pref + context.state.PUT.lessons.replace('{id}', data.id), { name: data.name })
                .then(response => {
                    context.commit('addLessons', response.data.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },

        deleteLesson(context, data){
            axios.delete(context.state.pref + context.state.DELETE.lesson.replace('{id}', data.id))
                .then(response => {
                    context.commit('addLessons', response.data.data);
                })
                .catch((error) => {
                    console.log(error)
                });
        },
    }
}