<modal :show.sync="showNew">
    <h3 slot="header">Create a New Scheme</h3>
    <div slot="body">
        <div v-show="subModuleToggle">
            <div>Save current scheme first?</div>
            <button class="button button--dark button--modal" v-on:click="subModule = !subModule, subModuleToggle = false">Save</button>
        </div>
        <div v-show="subModule" transition="slide-fade">
            <span>Scheme Name: </span>
            <input class="form form--modal" placeholder="Enter scheme name" v-model="schemeName">
            <div>
                <h5 class="modal__body-header">Saved Schemes</h5>
                <div class="modal__saves">
                    <div class="modal__saved" v-on:click="setSchemeName(name)" v-for="name in names">
                        @{{ name }}
                    </div>
                </div>
            </div>
            <button class="button button--dark button--modal" v-on:click="sendSave, subModule = false">Save</button>
        </div>
    </div>
    <div slot="footer">
        <button class="button button--dark button--modal" v-on:click="createNewScheme(), closeModal('New')">New</button>
        <button class="button button--dark button--modal" v-on:click="closeModal('New')">Cancel</button>
    </div>
</modal>