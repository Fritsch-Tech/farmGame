import Logo from '@/objects/logo';

export default class Game extends Phaser.Scene {
    /**
    *  A sample Game scene, displaying the Phaser logo.
    *
    *  @extends Phaser.Scene
    */
    constructor() {
        super({key: 'Game'});
        this.money = 100;
    }

    /**
    *  Called when a scene is initialized. Method responsible for setting up
    *  the game objects of the scene.
    *
    *  @protected
    *  @param {object} data Initialization parameters.
    */
    create() {
        this.centerX = this.cameras.main.width / 2;
        this.centerY = this.cameras.main.height / 2;
        this.add.text(0, 0, 'Money: '+this.money+'$');
        this.add.image(this.centerX,    this.centerY, 'spritesheet',0);
        this.add.image(this.centerX+16, this.centerY, 'spritesheet',1);
        //this.logo = this.add.existing(new Logo(this));
    }

    /**
    *  Called when a scene is updated. Updates to game logic, physics and game
    *  objects are handled here.
    *
    *  @protected
    *  @param {number} t Current internal clock time.
    *  @param {number} dt Time elapsed since last update.
    */
    update(/* t, dt */) {
        //this.logo.update();
    }
}
