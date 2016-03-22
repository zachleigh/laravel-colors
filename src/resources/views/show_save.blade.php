<modal :show.sync="showSave">
    <h3 slot="header">Save Your Scheme</h3>
    <div slot="body">
        <h5>Scheme Name: @{{ schemeName }}</h5>
        <input placeholder="Edit scheme name" v-model="schemeName">
    </div>
    <div slot="footer">
        <button class="button button--dark button--modal" @click="sendSave">Save</button>
    </div>
</modal>