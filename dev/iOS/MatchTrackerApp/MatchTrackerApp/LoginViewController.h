//
//  LoginViewController.h
//  MatchTrackerApp
//
//  Created by Jesse on 7/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "QuickDialogController.h"

@interface LoginViewController : QuickDialogController <QuickDialogStyleProvider, QuickDialogEntryElementDelegate> {
    
}

+ (QRootElement *)createAboutDetailsForm;
+ (QRootElement *)createLoginForm;

@end
