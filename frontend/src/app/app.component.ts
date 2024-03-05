import { Component } from '@angular/core';
import { trigger, transition, style, animate, query } from '@angular/animations';
import { group } from '@angular/animations';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],

  animations: [
    trigger('routeAnimations', [
      transition('* <=> *', [
        style({ position: 'relative' }),
        query(':enter, :leave', [
          style({
            position: 'absolute',
            width: '100%',
            top: 0,
            left: 0,
          })
        ], { optional: true }),
        group([
          query(':leave', [
            animate('0.3s ease-out', style({ opacity: 0 }))
          ], { optional: true }),
          query(':enter', [
            style({ opacity: 0 }),
            animate('0.1s ease-in-out', style({ opacity: 1 }))
          ], { optional: true })
        ])
      ]),
    ])
  ]
})
export class AppComponent {
  title = 'Frontend';
}