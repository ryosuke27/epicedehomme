var eventBus = new Vue()

Vue.component('product', {
    props: {
      premium: {
        type: Boolean,
        required: true
      }
    },
    template: `
     <div class="product">
          
        

         <product-tabs :reviews="reviews"></product-tabs>
      
      </div>
     `,
    data() {
      return {
          reviews: []
      }
    },

      mounted() {
        eventBus.$on('review-submitted', productReview => {
          this.reviews.push(productReview)
        })
      }
  })


  Vue.component('product-review', {
    template: `
    <form class="review-form" @submit.prevent="onSubmit">

    <p>
      <label for="name">Name:</label>
      <input class="name" v-model="name">
    </p>
    
    <p>
      <label for="review">Review:</label>      
      <textarea class="review" v-model="review"></textarea>
    </p>
    
    <p>
      <label for="rating">Rating:</label>
      <select class="rating" v-model.number="rating">
        <option>5</option>
        <option>4</option>
        <option>3</option>
        <option>2</option>
        <option>1</option>
      </select>
    </p>
        
    <p>
      <input type="submit" value="Submit">  
    </p>    
  
   </form>
    `,
    data() {
      return {
        name: null,
        review: null,
        rating: null,
        errors: []
      }
    },
    methods: {
      onSubmit() {
        this.errors = []
        if (this.name && this.review && this.rating) {
          let productReview = {
            name: this.name,
            review: this.review,
            rating: this.rating
          }
          eventBus.$emit('review-submitted', productReview)
          this.name = null
          this.review = null
          this.rating = null
        }
        else {
          if(!this.name) this.errors.push("Name required.")
          if(!this.review) this.errors.push("Review required.")
          if(!this.rating) this.errors.push("Rating required.")
        }
      }
    }
  })

  Vue.component('product-tabs', {
    props: {
      reviews: {
        type: Array,
        required: false
      }
    },
    template: `
      <div>
      
        <div>
          <span class="tabs" 
                :class="{ activeTab: selectedTab === tab }"
                v-for="(tab, index) in tabs"
                :key="index"
                @click="selectedTab = tab"
          >{{ tab }}</span>
        </div>

        <div v-show="selectedTab === 'Reviews'">
            <p v-if="!reviews.length">There are no reviews yet.</p>
            <ul v-else>
                <li v-for="review in reviews">
                  <p>{{ review.name }}</p>
                  <p>Rating:{{ review.rating }}</p>
                  <p>{{ review.review }}</p>
                </li>
            </ul>
        </div>

        <div v-show="selectedTab === 'Make a Review'">
          <product-review></product-review>
        </div>
    
      </div>
    `,
    data() {
      return {
        tabs: ['Reviews', 'Make a Review'],
        selectedTab: 'Reviews'
      }
    }
  })

  
  var app = new Vue({
      el: '#app',
      data: {
        premium: true
      }
  })
