<modal :show.sync="showLoad">
    <h3 slot="header">Load Scheme</h3>
    <div slot="body">
        <h5 class="modal__body-header">Saved Schemes</h5>
        <div class="modal__saves">
            <div class="modal__saved" v-on:click="loadScheme(name)" v-for="name in names">
                @{{ name }}
            </div>
        </div>
    </div>
    <div slot="footer">
        <button class="button button--dark button--modal" v-on:click="showLoad = false">Ok</button>
        <button class="button button--dark button--modal" v-on:click="closeModal('Load'), restoreScheme()">Cancel</button>
    </div>
</modal>