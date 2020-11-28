<template>
<div>
    <button class="btn btn-sm btn-primary mb-2" @click="createCompany()">New Company</button>
    
    <div class="clearfix"></div>
    <!-- DataTales Example -->
    <div v-show="showMessage" class="alert alert-success alert-dismisable fade show" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{message}}</strong>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Companies</h6>
        </div>
        <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable-company" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Created by</th>
                <th>Action</th>                     
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Created by</th>
                <th>Action</th> 
            </tr>
            </tfoot>
            <tbody>
                        <tr v-for="(company, index) in allCompanies" :key='index'>
                            <td>{{index + 1}}</td>
                            <td class='font-weight-bold'>{{company.name}}</td>
                            <td>{{company.email}}</td>
                            <td>{{company.user_id}}</td>
                            <td>
                                <button @click="editCompany(company)"  class='btn btn-outline-warning btn-sm'><i class="text-yellow fas fa-edit"></i></button>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
        <create-company></create-company>
</div>
</template>

<script>
export default {
    props: ['companies'],

    mounted() {
        
        this.$on('companyCreated', (company) => {
            this.showAlert('Company created successfully.', 4000);
            this.allCompanies.push(company);
        })
    },

    components: {
        "create-company": require('./children/CreateCompany.vue').default
    },

    data() {
        return {
            allCompanies: this.companies,
            message:'',
            showMessage: false
        }
    },

    methods:{
        createCompany(){
            this.$emit('createNewCompany');
        },

        showAlert(message, time){
            this.message = message;
            this.showMessage = true;
            
            setInterval(() => {
                this.showMessage = false;
                this.message = '';
            }, time);
        }
    }

}
</script>