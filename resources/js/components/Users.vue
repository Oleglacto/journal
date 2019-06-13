<template>
    <div>
        <header style="display: flex; align-items: center; margin-bottom: 20px;">
            <h1>Список пользователей</h1>
            <div style="margin-right: 0; margin-left: auto;">

            </div>
        </header>
        <el-table
                :data="users"
                border
                @filter-change="filterBy">
            <el-table-column
                    prop="full_name"
                    label="ФИО">
            </el-table-column>
            <el-table-column
                    prop="group"
                    label="Группа"
                    column-key="byGroup"
                    filtered
                    :filters="groupFilters()">
            </el-table-column>
            <el-table-column
                    prop="role"
                    label="Должность"
                    column-key="byRole"
                    filtered
                    :filter-multiple="false"
                    :filters="roleFilters()">
            </el-table-column>
            <el-table-column prop="user"  :width="170">
                <template slot-scope="user">
                    <el-button type="success" icon="el-icon-info" circle @click="showUser(user)"></el-button>
                    <el-button type="primary" icon="el-icon-edit" circle @click="showEditForm(lesson_id)"></el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
                background
                @current-change="changePage"
                layout="prev, pager, next"
                :total="total_pages"
                :page-size="per_page"
                :current-page="current_page"
        >
        </el-pagination>
        <el-dialog
                title="Информация о студенте"
                :visible.sync="dialogVisible"
                width="50%">
                <div class="row"><span class="text">ФИО:</span> {{ this.user.full_name }}</div>
                <div class="row">
                    <h1 class="header">Зачетка</h1>
                    <el-table
                            :data="user.recordBook"
                            border>
                        <el-table-column
                                prop="name"
                                label="Название дисциплины">
                        </el-table-column>
                        <el-table-column
                                prop="mark"
                                label="Оценка">
                        </el-table-column>
                    </el-table>
                </div>
                <div class="row">
                    <h1 class="header">Посещения</h1>
                    <el-table
                            :data="user.visitLog"
                            border>
                        <el-table-column
                                prop="name"
                                label="Название дисциплины">
                        </el-table-column>
                        <el-table-column
                                prop="percentOfVisitedLessons"
                                label="Процент посещенных занятий">
                        </el-table-column>
                    </el-table>
                </div>
                <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="dialogVisible = false">Закрыть</el-button>
              </span>
        </el-dialog>
        <el-dialog
                title="Добавление пользователя"
                :visible.sync="formCreateVisible"
                width="30%">
            <el-form ref="form" :model="form" @submit.native.prevent="" label-width="120px" style="width: 100%">
                <el-form-item label="Имя">
                    <el-input placeholder="Имя" v-model="form.first_name"></el-input>
                </el-form-item>
                <el-form-item label="Фамилия">
                    <el-input placeholder="Фамилия" v-model="form.last_name"></el-input>
                </el-form-item>
                <el-form-item label="Отчество">
                    <el-input placeholder="Отчество" v-model="form.middle_name"></el-input>
                </el-form-item>
                <el-form-item label="Должность">
                    <el-select id="role_id" v-model="form.role_id" placeholder="Должность">
                        <el-option
                                v-for="role in rolesList"
                                :key="role.role_id"
                                :label="role.role"
                                :value="role.role_id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Группа">
                    <el-select id="group_id" v-model="form.group_id" placeholder="Группа">
                        <el-option
                                v-for="group in groupList"
                                :key="group.group_id"
                                :label="group.name"
                                :value="group.group_id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="success" @click="createStudent">Сохранить</el-button>
                <el-button type="primary" @click="formCreateVisible = false">Закрыть</el-button>
            </span>
        </el-dialog>
        <el-button type="primary" icon="el-icon-circle-plus" class="create--button" @click="openCreateForm"></el-button>
    </div>
</template>

<script>
    import {mapActions, mapGetters, mapState} from "vuex";
    import get from 'lodash/get';

    export default {
        name: "Users.vue",
        data() {
            return {
                user: {},
                dialogVisible: false,
                formCreateVisible: false,
                form: {
                    middle_name: '',
                    first_name: '',
                    last_name: '',
                    group_id: null,
                    role_id: 1
                },
            }
        },

        created() {
            this.getUsers(this.$route.query);
            this.getServiceInfo();
        },

        computed: {
            ...mapState({
                total_pages: state => get(state, 'users.users.meta.pagination.total'),
                per_page: state => get(state, 'users.users.meta.pagination.per_page'),
                current_page: state => get(state, 'users.users.meta.pagination.current_page'),
                meta: state => get(state, 'users.meta'),
                users: state => get(state, 'users.users.data', []),
            }),

            ...mapGetters([
                'rolesList',
                'groupList'
            ]),

            // groups() {
            //     return this.$store.getters.scheduleInformation.groups
            // },
            currentPage() {
                return this.$store.getters.usersList.meta.pagination.current_page
            },
            pageSize() {
                return this.$store.getters.usersList.meta.pagination.per_page
            },

            hasRecordBookRecords() {
                return (this.user.recordBook && this.user.recordBook.length) || false;
            },

            percentOfVisitedLessons() {
                // if (this.user.visitLog && this.user.visitLog.length) {
                //     return this.user.visitLog.visited / this.user.visitLog.lessons_count * 100;
                // }
                return '0';
            },
        },

        methods: {
            ...mapActions([
                'getUsers',
                'getServiceInfo'
            ]),
            roleFilters() {
                let filters = [];
                _.forEach(this.rolesList, (item) => {
                    filters.push({
                        'text': item.role,
                        'value': item.role_id
                    })
                });

                return filters;
            },
            groupFilters() {
                let filters = [];
                _.forEach(this.groupList, (item) => {
                    filters.push({
                        'text': item.name,
                        'value': item.group_id
                    })
                });

                return filters;
            },

            filterBy(filtersList) {

                let query = {};
                Object.assign(query, this.$route.query);

                query.page = 1;

                _.forEach(filtersList, (item, key) => {
                    if (item.length) {
                        query[key] = item.join(',');
                    } else {
                        delete(query[key]);
                    }
                });

                this.getUsers(query);

                this.$router.push({ name: 'users', query });
            },

            openCreateForm() {
                this.formCreateVisible = true;
            },

            changePage(page) {
                let query = {};
                Object.assign(query, this.$route.query);
                query.page = page;

                this.$router.push({ name: 'users', query });
                this.getUsers(query);
            },

            showUser(user) {
                let result = this.$store.dispatch('getUser', {id: user.row.user_id });
                result.then((result) => {
                    this.user = result.data;
                    this.dialogVisible = true;
                }).catch(error => {

                })
            },

            createStudent() {
                this.$store.dispatch('addUser', this.form)
            },
        },

        props: {
            page: {
                type: Number,
            }
        },
    }
</script>

<style scoped>
    .el-pagination.is-background {
        margin-top: 20px;
        margin-left: -10px;
    }
    .header {
        font-size: 14px;
        color: #363636;
        font-weight: bold;
        padding: 13px 10px;
        border: 1px solid #EBEEF5;
        border-bottom: none;
    }

    .text {
        font-size: 14px;
        color: #363636;
        font-weight: bold;
    }

    .row {
        margin-bottom: 10px;
    }

    .create--button {
        position: absolute;
        right: 0;
        top: 70px;
    }
</style>