<template>
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary col-md-9">Candidates</h6>    
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Candidate</th>
                            <th>Voter</th>             
                            <th>Recorded At</th>             
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Candidate</th>
                            <th>Voter</th>
                            <th>Recorded At</th>  
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(vote, index) in pollVotes" :key='index'>
                            <td>{{index + 1}}</td>
                            <td class='font-weight-bold'>{{vote.candidate}}</td>
                            <td>{{vote.attendee}}</td>
                            <td>{{vote.time}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props:['pollVotes'],

    data() {
        return {
            
        }
    },

    methods: {
    }

}
</script>