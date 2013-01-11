//
//  Team.h
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Player.h"

@interface Team : NSObject

@property (nonatomic, retain) NSString* identifier;
@property (nonatomic, retain) NSString* name;
@property (nonatomic, retain) NSString* email;
@property (nonatomic, retain) NSString* place;
@property (nonatomic, retain) NSString* weekday;
@property (nonatomic, retain) NSString* hours;


@end
