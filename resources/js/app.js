/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/es'
window.Vue = require('vue');
Vue.use(ElementUI,{locale});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


Vue.component('levels-index', require('./components/Levels/IndexComponent.vue').default);
Vue.component('levels-details', require('./components/Levels/DetailsComponent.vue').default);
Vue.component('levels-create-edit', require('./components/Levels/CreateEditComponent.vue').default);

Vue.component('courses-index', require('./components/Courses/IndexComponent.vue').default);
Vue.component('courses-details', require('./components/Courses/DetailsComponent.vue').default);
Vue.component('courses-create-edit', require('./components/Courses/CreateEditComponent.vue').default);

Vue.component('schedules-index', require('./components/Schedules/IndexComponent.vue').default);
Vue.component('schedules-details', require('./components/Schedules/DetailsComponent.vue').default);
Vue.component('schedules-create-edit', require('./components/Schedules/CreateEditComponent.vue').default);

Vue.component('table-component', require('./components/UsersCdu/TableComponent.vue').default);
Vue.component('agregar-component', require('./components/UsersCdu/AddComponent.vue').default);
Vue.component('vistauser-component', require('./components/UsersCdu/ViewComponent.vue').default);
Vue.component('details-component', require('./components/UsersCdu/DetailsComponent.vue').default);

Vue.component('tableAreas-component', require('./components/Areas/TableComponent.vue').default);
Vue.component('agregarAreas-component', require('./components/Areas/AddComponent.vue').default);
Vue.component('detailsAreas-component', require('./components/Areas/DetailsComponent.vue').default);
Vue.component('viewareas-component', require('./components/Areas/ViewComponent.vue').default);

Vue.component('tableDiscipline-component', require('./components/Discipline/TableComponent.vue').default);
Vue.component('agregarDiscipline-component', require('./components/Discipline/AddComponent.vue').default);
Vue.component('detailsDiscipline-component', require('./components/Discipline/DetailsComponent.vue').default);
Vue.component('viewdiscipline-component', require('./components/Discipline/ViewComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('form-role-component', require('./components/Roles/FormRoleComponent.vue').default);
Vue.component('role-component', require('./components/Roles/RoleComponent.vue').default);
Vue.component('my-roles-component', require('./components/Roles/MyRolesComponent.vue').default);

Vue.component('form-user-component', require('./components/Users/FormUserComponent.vue').default);
Vue.component('user-component', require('./components/Users/UserComponent.vue').default);
Vue.component('my-users-component', require('./components/Users/MyUsersComponent.vue').default);
Vue.component('users-create-edit', require('./components/Users/CreateEditUserComponent.vue').default);

Vue.component('form-instructor-component', require('./components/Instructors/FormInstructorComponent.vue').default);
Vue.component('instructor-component', require('./components/Instructors/InstructorComponent.vue').default);
Vue.component('my-instructors-component', require('./components/Instructors/MyInstructorsComponent.vue').default);

Vue.component('form-payment-component', require('./components/Payments/FormPaymentComponent.vue').default);
Vue.component('payment-component', require('./components/Payments/PaymentComponent.vue').default);
Vue.component('my-payments-component', require('./components/Payments/MyPaymentsComponent.vue').default);
Vue.component('payments-create-edit', require('./components/Payments/CreateEditPaymentComponent.vue').default);
Vue.component('detail-payment-component', require('./components/Payments/DetailPaymentComponent.vue').default);

Vue.component('form-concept-component', require('./components/Concepts/FormConceptComponent.vue').default);
Vue.component('concept-component', require('./components/Concepts/ConceptComponent.vue').default);
Vue.component('my-concepts-component', require('./components/Concepts/MyConceptsComponent.vue').default);
Vue.component('concepts-create-edit', require('./components/Concepts/CreateEditConceptComponent.vue').default);
Vue.component('detail-concept-component', require('./components/Concepts/DetailConceptComponent.vue').default);

const app = new Vue({
    el: '#app',
});
