import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { AppModule } from './app/app.module';
import { Injector } from '@angular/core';
import { AuthService } from './app/services/AuthService.service';

platformBrowserDynamic().bootstrapModule(AppModule)
  .then((moduleRef) => {
    const injector: Injector = moduleRef.injector;
    const authService: AuthService = injector.get(AuthService);
    authService.autoLogin().subscribe();
  })
  .catch(err => console.error(err));