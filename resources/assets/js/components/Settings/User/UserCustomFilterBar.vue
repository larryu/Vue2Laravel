<template>
    <div class="filter-bar">
        <form class="form-inline">
            <div class="form-group">
                <label>Search for:</label>
                <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="name, nickname, or email">
                <button class="btn btn-success" @click.prevent="doFilter">Search</button>
                <button class="btn btn-warning" @click.prevent="resetFilter">Reset</button>
                <button class="btn btn-primary" title="New" @click.prevent="onClickNew">
                    <span class="glyphicon glyphicon-plus"></span>NEW
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                filterText: ''
            }
        },
        methods: {
            doFilter () {
                this.$events.fire('filter-set', this.filterText)
            },
            resetFilter () {
                this.filterText = '';
                this.$events.fire('filter-reset')
            },
            onClickNew() {
                console.log('UserCustomFilterBar onClickNew')
                this.$emit('onClickNew', {action: 'Add'});
            }
        }
    }
</script>
<style>
    .filter-bar {
        padding: 10px;
    }
</style>