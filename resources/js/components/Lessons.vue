<template>
    <div>
        <header style="display: flex; align-items: center; margin-bottom: 20px;">
            <h1>Список занятий</h1>
            <div style="margin-right: 0; margin-left: auto;">

            </div>
        </header>
        <el-row :gutter="20">
            <el-col :span="12">
                <el-table
                        :data="lessons"
                        @header-click="openSearchModal"
                        border>
                    <el-table-column
                            prop="name"
                            label="Название дисциплины">
                    </el-table-column>
                    <el-table-column prop="lesson_id"  :width="120">
                        <template slot-scope="lesson_id">
                            <el-button  type="primary" icon="el-icon-edit" circle @click="showEditForm(lesson_id)"></el-button>
                            <el-button type="danger" @click="deleteLesson(lesson_id)" icon="el-icon-delete" circle></el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-col>
            <el-col :span="11" v-show="create">
                <h2 class="header">Добавление дисциплины</h2>
                <el-form class="form" ref="form" :model="form" @submit.native.prevent="storeLesson" label-width="120px" style="width: 100%" border>
                    <el-form-item label="Название">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item style="margin-bottom: 0">
                        <el-button type="primary" @click="storeLesson" :disabled="inputIsEmpty">Создать</el-button>
                        <el-button>Сбросить</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
            <el-col :span="11" v-show="!create">
                <h1 class="header">Редактирование дисциплины</h1>
                <el-form class="form" ref="form" :model="form" @submit.native.prevent="updateLesson" label-width="120px" style="width: 100%" border>
                    <el-form-item label="Название">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item style="margin-bottom: 0">
                        <el-button type="primary" @click="updateLesson" :disabled="inputIsEmpty">Изменить</el-button>
                        <el-button>Сбросить</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-dialog
                :title="searchBy"
                :visible.sync="searchFormVisible"
                width="30%">
            <el-input placeholder="Поиск" v-model="search"></el-input>
            <span slot="footer" class="dialog-footer">
                <el-button @click="searchFormVisible = false">Закрыть</el-button>
                <el-button type="primary" @click="makeSearch">Поиск</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        data() {
            return {
                form: {
                    name: ''
                },
                lessonId: '',
                create: true,
                emptyData: '',
                searchFormVisible: false,
                search: '',
                openedHeaderCell: {}
            }
        },

        mounted() {
            this.getLessons();
            _.forEach(this.$route.query, function (item, key) {
                console.log(item, key);
            })
        },

        computed: {
            lessons() {
                return this.$store.getters.lessonsList
            },

            searchBy() {
                return 'Поиск по названию дисциплины'
            },

            inputIsEmpty() {
                return this.form.name.length === 0
            },

            searchAvailable() {
                return this.search && this.search.length > 1;
            },
        },

        watch: {
            $route(to, from) {
                if (to.query.name) {

                }
            }
        },

        methods: {
            ...mapActions([
                'getLessons'
            ]),

            storeLesson() {
                this.$store.dispatch('saveLesson', { name: this.form.name });
                this.showNotification('Добавлено');
                this.form.name = '';
            },

            openSearchModal(column) {
                this.searchFormVisible = true;
                this.search = this.$route.query[column.property];
                this.openedHeaderCell = column;
            },

            showEditForm(data) {
                this.create = !this.create;
                this.lessonId = data.row.lesson_id;
                this.form.name = this.create ? '' : data.row.name;
            },

            updateLesson() {
                this.$store.dispatch('updateLesson', { id: this.lessonId, name: this.form.name });
                this.showNotification('Обновлено');
                this.create = true;
                this.form.name = '';
            },

            deleteLesson(data) {
                this.$store.dispatch('deleteLesson', { id: data.row.lesson_id });
                this.showNotification('Дисциплина "'+ data.row.name +'" удалена');
            },

            showNotification(message) {
                this.$notify({
                    title: 'Успешно',
                    message: message,
                    type: 'success',
                    duration: 1500
                });
            },

            makeSearch() {
                let query = {};
                Object.assign(query, this.$route.query);

                if (!this.searchAvailable) {
                    delete (query.name);
                    console.log(query);
                    this.getLessons(query);
                    this.$router.push({ name: 'lessons', query });
                    return;
                }

                query.name = this.search;

                this.getLessons(query);

                this.$router.push({ name: 'lessons', query });
            }

        }
    }
</script>

<style>
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
        margin-bottom: 0;
    }
    .isActive {
        color: blue;
    }
</style>