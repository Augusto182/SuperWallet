import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LoadWalletComponent } from './load-wallet.component';

describe('LoadWalletComponent', () => {
  let component: LoadWalletComponent;
  let fixture: ComponentFixture<LoadWalletComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [LoadWalletComponent]
    });
    fixture = TestBed.createComponent(LoadWalletComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
