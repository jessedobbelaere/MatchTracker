//
//  FirstViewController.h
//  MatchTrackerApp
//
//  Created by Jesse on 3/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <RestKit/RestKit.h>

@interface FirstViewController : UIViewController


@property(strong, atomic) RKObjectManager *manager;

@end
