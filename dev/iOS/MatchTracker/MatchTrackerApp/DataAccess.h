//
//  DataAccess.h
//  MatchTrackerApp
//
//  Created by Jesse on 4/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <RestKit/RestKit.h>

@interface DataAccess : NSObject <RKRequestDelegate>

// Shared singleton
+ (DataAccess *) sharedDataAccess;

// Methods
- (void) getData;

@end
