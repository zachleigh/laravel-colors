<modal class="save" :show.sync="showSave">
    <h3 slot="header">Save Your Scheme</h3>
    <div slot="body">
        <span>Scheme Name: </span>
        <input class="form form--modal" placeholder="Enter scheme name" v-model="schemeName">
        <div>
            <h5 class="modal__body-header">Saved Schemes</h5>
            <div class="save__saves">
                <div class="save__saved" v-on:click="setSchemeName(name)" v-for="name in names">
                    @{{ name }}
                </div>
            </div>
        </div>
    </div>
    <div slot="footer">
        <button class="button button--dark button--modal" v-on:click="sendSave">Save</button>
    </div>
</modal>