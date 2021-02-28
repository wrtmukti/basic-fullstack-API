<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-8">
        <router-link 
        :to="{name: 'transaction.create'}"
        class="btn btn-primary btn-sm rounded shadow mb-3"
        >ADD
        </router-link>

        <div class="card rounded shadow">
          <div class="card-header">
            Transactions List
          </div>
          <div class="card-body">
            <div class="table">
              <thead>
                <tr >
                  <th>Title</th>
                  <th>Amount</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(transaction, index) in transactions.data" :key="index">
                  <td>{{ transaction.title }}</td>
                  <td>{{ transaction.amount }}</td>
                  <td>{{ transaction.type }}</td>
                  <td>
                    <div class="btn-group">
                      <router-link 
                      :to="{name:'transaction.edit', params:{id:transaction.id}}"
                      class="btn btn-sm btn-outline-info"                     
                      >Edit</router-link>
                      <button class="btn btn-sm btn-outline-danger"
                      @click.prevent="destroy(transaction.id, index)"
                      >
                        Delete
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {onMounted, ref} from 'vue'

export default {
  setup() {
    //reactive state
    let transactions = ref([]);
    onMounted(()=> {
      //get data from api endpoint
      axios.get('http://localhost:8000/api/transaction')
      .then((result)=>{
          transactions.value = result.data
        }).catch((err) => {
          console.log(err.response)
          });
      });

    function destroy(id, index) {
       axios.delete(
        `http://127.0.0.1:8000/api/transaction/${id}`
        )
        .then(() =>{
            transactions.value.data.splice(index, 1)
          }).catch((err)=> {
              console.log(err.response.data)
            });
      }

      return {
        transactions,
        destroy
        }
  }
}
</script>
