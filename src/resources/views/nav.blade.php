<header class="nav">
    <div class="nav__list">
        <div class="nav__section">
            <li class="menu__head" v-on:click="toggleMenu">Menu</li>
            <span class="invisible menu__head">Filler</span>
        </div>
        <div class="nav__section nav__item nav__logo">Laravel Colors</div>
        <div class="nav__section">
            <button class="nav__item button button--menu" v-on:click="addColor">Add</button>
        </div>
    </div>
</header>