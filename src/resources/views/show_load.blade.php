<modal :show.sync="showLoad">
    <h3 slot="header">Load Scheme</h3>
    <div slot="body">
        <div class="scheme-list">
            <span class="scheme-list__item" v-for="save in saves" v-on:click="loadScheme(save.name)">@{{ save.name }}</span>
        </div>
    </div>
    <div slot="footer">
        
    </div>
</modal>