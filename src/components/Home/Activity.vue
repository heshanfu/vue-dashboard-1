<template>
  <div class="activity">
    <h2>Current Activity</h2>
    <ul>
      <activity-item
        v-for="item in activity"
        v-bind:key="item.id"
        v-bind:activity_item="item"
      />
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'
import ActivityItem from '@/components/Home/Activity/ActivityItem'

export default {
  name: 'Activity',
  components: {
    'activity-item': ActivityItem
  },
  methods: {
    processActivity: function () {
      fetch('/static/php/Home/activity.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(activityItems => {
          let cache = []
          activityItems.forEach(activityItem => {
            let newActivityItem = activityItem
            cache.push(newActivityItem.id)
            if (this.activity !== [] && typeof this.activity.find(item => (item.id === newActivityItem.id)) !== 'undefined') {
              Vue.set(this.activity, this.activity.findIndex(item => item.id === newActivityItem.id), newActivityItem)
            } else {
              this.activity.push(newActivityItem)
            }
          })
          this.activity.forEach(activityItem => {
            if (!cache.includes(activityItem.id)) {
              Vue.delete(this.activity, this.activity.findIndex(item => item.id === activityItem.id))
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    clearAll: function () {
      this.activity = []
    }
  },
  data () {
    return {
      activity: [],
      update: null
    }
  },
  created () {
    this.clearAll()
    this.processActivity()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.processActivity()
    }, 10000)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  text-align: left;
  margin: 20px 107px;
  font-size: 28px;
  font-weight: 100;
  letter-spacing: 1px;
}
ul {
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  justify-content: flex-start;
  padding: 0 96px;
  list-style-type: none;
}
ul:empty::after {
  content: "Nothing to Show";
  width: 100%;
  font-size: 13px;
  color: rgb(153, 153, 153);
  text-align: center;
  padding: 15px;
  margin: 0 27px 0 11px;
  background: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}
</style>
